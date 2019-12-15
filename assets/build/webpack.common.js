const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin'); //This genetates automatically the index.html even if we already have one
const { CleanWebpackPlugin } = require('clean-webpack-plugin'); //This clean up the dist folder if there is something unused
const ManifestPlugin = require('webpack-manifest-plugin'); //This will generate a manifest file
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const devMode = process.env.NODE_ENV !== 'production';

module.exports = {
    entry: {
        app: [
            './assets/scripts/main.js',
            './assets/styles/main.scss'
        ]
    },
    output: {
        filename: 'scripts/[name].[hash].js',
        path: path.resolve(__dirname, '../../dist'),
    },
    module: {
        rules: [
            {
                //https://webpack.js.org/guides/asset-management/#loading-css
                test: /\.css$/,
                use: [
                    'cache-loader',
                    'style-loader',
                    'css-loader',
                ]
            },
            {
                test: /\.s[ac]ss$/,
                use: [
                    'cache-loader',
                    devMode ? 'style-loader' : MiniCssExtractPlugin.loader,
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                include: path.resolve(__dirname, 'src'),
                use: [
                    'cache-loader',
                    'file-loader',
                    {
                        loader: 'image-webpack-loader',
                        options: {
                            bypassOnDebug: true, // webpack@1.x
                            disable: true, // webpack@2.x and newer
                            mozjpeg: {
                                progressive: true,
                                quality: 65
                            },
                            // optipng.enabled: false will disable optipng
                            optipng: {
                                enabled: false,
                            },
                            pngquant: {
                                quality: '65-90',
                                speed: 4
                            },
                            gifsicle: {
                                interlaced: false,
                            },
                            // the webp option will enable WEBP
                            webp: {
                                quality: 75
                            }
                        },
                    },
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192,
                        },
                    },
                ]
            },
            {
                //https://webpack.js.org/guides/asset-management/#loading-fonts
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    'file-loader'
                ]
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new HtmlWebpackPlugin(),
        new ManifestPlugin(),
        new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: devMode ? 'styles/[name].[hash].css' : 'styles/[name].css',
            chunkFilename: devMode ? '[id].css' : '[id].css',
            ignoreOrder: true,
        }),
    ],
};