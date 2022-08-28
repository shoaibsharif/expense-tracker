const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./resources/**/*.{css,js}",
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.yellow,
                success: colors.green,
                warning: colors.amber,
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
