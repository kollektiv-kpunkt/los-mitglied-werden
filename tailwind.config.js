/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/**/*.json"
    ],
    theme: {
        extend: {
            colors: {
                accent: "#D60B52",
                background: "#010E1F",
            }
        },
    },
    plugins: [],
}
