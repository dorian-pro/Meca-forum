const path = require('path');
const webpack = require('@symfony/webpack-encore');

module.exports = {
    entry: {
        app: './assets/js/app.js',
        vendor: ['jquery'],
    },
    output: {
        path: path.resolve(__dirname, 'public/build'),
        filename: '[name].js',
        publicPath: '/build',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
    plugins: [
        new webpack.autoProvideVariables({
            $: 'jquery',
            jQuery: 'jquery',
        }),
    ],
};