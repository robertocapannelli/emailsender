const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');

module.exports = merge(common, {
    mode: 'development',
    devtool: 'inline-source-map',
    devServer: {
        contentBase: path.join(__dirname, '../'),
        compress: true,
        hot: true,
        //See this https://github.com/webpack/webpack-dev-server/issues/923
        inline: true,
        port: 3000,
        proxy: {
            '*': {
                target: 'http://emailsender.com.loc',
                secure: false,
                changeOrigin: true,
            }
        },
        historyApiFallback: true
    }
});