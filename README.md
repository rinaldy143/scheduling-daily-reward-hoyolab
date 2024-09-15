# Daily Reward Claim Program
## Overview
This program automates the process of claiming rewards from HoYoLab for Genshin Impact and Honkai Star Rail. It runs daily at 05:00 AM (UTC) and updates the database with the latest rewards.

## How to Get Your HoYoLab Cookie

To use this program, you need to obtain your HoYoLab cookie. Follow the steps below:

1. **Login**: Log in to your HoYoLab account or Genshin Battlepass.

2. **Get Cookie**:
    - Open your browser and go to the address bar.
    - Type `java` and press Enter.
    - Copy and paste the following script into the address bar and press Enter:
   
    
```javascript
script: (function() {
  if (document.cookie.includes('ltoken') && document.cookie.includes('ltuid')) {
    const input = document.createElement('input');
    input.value = document.cookie;
    document.body.appendChild(input);
    input.focus();
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    if (result) {
      alert('HoYoLAB cookie copied to clipboard');
    } else {
      prompt('Failed to copy cookie. Manually copy the cookie below:\n\n', input.value);
    }
  } else {
    alert('Please logout and log back in. Cookie is expired/invalid!');
  }
})();
```
3. **Copy Cookie**

4.  **After running the script, click the "Click here to copy!" button to copy your cookie to the clipboard.**

## Insert Cookie:

Paste your cookie into the user menu of the program.
## How It Works

Daily Automation: The program automatically runs every day at 05:00 AM (UTC) to claim rewards.

Database Update: The rewards are stored in the database, and the status of the cookies is updated accordingly.

Error Handling: If any errors occur, they are logged and handled properly.

## References

For detailed instructions on obtaining and using HoYoLab cookies, please refer to the documentation: [HoYoLab Cookie Documentation](https://vermaysha.github.io/hoyoapi/docs/guide/get-started).

## Acknowledgements

Thank you to the developers and maintainers of the HoYoAPI for providing the tools and documentation that make this program possible.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
