import pg from 'pg'; // Import default
const { Pool } = pg; // Ambil Pool dari objek default
import dotenv from 'dotenv';
import { GenshinImpact, HonkaiStarRail, LanguageEnum } from 'hoyoapi';

dotenv.config();

const pool = new Pool({
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    database: process.env.DB_DATABASE,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
});

async function getCookieFromDatabase(userId) {
    if (!userId) {
        throw new Error('User ID is required');
    }

    const query = 'SELECT cookie FROM cookies WHERE user_id = $1';
    const values = [userId];
    try {
        const res = await pool.query(query, values);
        if (res.rows.length > 0) {
            return res.rows[0].cookie;
        }
        throw new Error('No cookie found for the given user ID');
    } catch (err) {
        console.error('Error fetching cookie from database:', err);
        throw err;
    }
}

async function main() {
    try {
        const userId = process.argv[2]; // Ambil userId dari argumen baris perintah
        if (!userId) {
            throw new Error('User ID argument is missing');
        }

        const cookie = await getCookieFromDatabase(userId);

        const genshin = new GenshinImpact({
            cookie: cookie,
            lang: LanguageEnum.ENGLISH,
        });

        const hsr = new HonkaiStarRail({
            cookie: cookie,
            lang: LanguageEnum.ENGLISH, // optional
        });

        // Claim the daily rewards.
        const claimHsr = await hsr.daily.claim();
        console.log(JSON.stringify(claimHsr));

        const claim = await genshin.daily.claim();
        console.log(JSON.stringify(claim));

    } catch (error) {
        console.error(JSON.stringify({
            message: error.message,
            code: error.code || -1,
            stack: error.stack,
            response: error.http?.response || null,
        }));
        process.exit(1); // Pastikan exit dengan kode 1 untuk menandakan error
    } finally {
        try {
            await pool.end(); // Tutup koneksi database
        } catch (err) {
            console.error('Error closing database connection:', err);
        }
    }
}

main();
