/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                astronautBlue: {
                   100: '#D3E3EC',
                   200: '#87B1CB',
                   300: '#4C85A7',
                   400: '#2C5B7D',
                   500: '#093E60',
                   primary: '#063F5F',
                },
                ballBlue: {
                   100: '#C6E9F2',
                   200: '#92D6E8',
                   300: '#61C4DD',
                   400: '#1DA9CC',
                   500: '#19849E',
                   primary: '#16A9B7',
                },
                dustyOrange: {
                   100: '#FEF1E7',
                   200: '#F8D3BA',
                   300: '#F5B88D',
                   400: '#F39C63',
                   500: '#EF8239',
                   primary: '#E97D32',
                },
                columbiaBlue: {
                   100: '#E9F7FE',
                   200: '#D2EEFC',
                   300: '#BEE7FB',
                   400: '#A9E0FA',
                   500: '#8BC5E1',
                   primary: '#9FDCF8',
                },
                darkTurquoise: {
                   100: '#C2E7EB',
                   200: '#A8DDE3',
                   300: '#9CDAE5',
                   400: '#55C5CD',
                   500: '#47C2CA',
                   primary: '#42BEAF',
                },
                jasmine: {
                   100: '#FCF3D3',
                   200: '#FBEFC4',
                   300: '#F8E7A8',
                   400: '#F7DF8B',
                   500: '#DBC470',
                   primary: '#FFDE86',
                },
            },
            width: {

            },
            borderColor: {

            },
            borderRadius: {

            },
            fontFamily: {
                poppins: "Poppins",
            },
            fontSize: {

            },
            screens: {
                // xs: { max: "600px" },
            },

            boxShadow: {

            }
        },
    },
    plugins: [],
}
