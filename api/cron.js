// api/cron.js
import { exec } from 'child_process';

export default async function handler(req, res) {
    try {
        const { stdout, stderr } = await exec('php artisan run:nodescript');
        console.log('stdout:', stdout);
        console.error('stderr:', stderr);
        res.status(200).json({ message: 'Cron job executed successfully' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Error executing cron job' });
    }
}
