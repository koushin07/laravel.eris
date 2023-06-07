const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/export/*.blade.php",
        "./resources/views/export/inventory/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                roman:"Times New Roman, Times, serif",
                arial: "Arial, sans-serif",
                american: "American Typewriter, serif",
                tohama: "font-family: Tahoma, sans-serif",
            },
            keyframes: {
                wiggle: {
                    "0%, 100%": {
                        transform: "rotate(-3deg)",
                    },
                    "50%": {
                        transform: "rotate(3deg)",
                    },
                },
                "fade-in-down": {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(-10px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                "fade-out-up": {    
                    "0": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                    "50": {
                        opacity: "1",
                        transform: "translateY(-5px)",
                    },
                    "100": {
                        opacity: "0",
                        transform: "translateY(-10px)",
                    },
                },
            },
            animation: {
                wiggle: "wiggle 1s ease-in-out infinite",
                "fade-in-down": "fade-in-down 0.5s ease-out",
                "fade-out-up": "fade-out-up 0.5s ease-out",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
