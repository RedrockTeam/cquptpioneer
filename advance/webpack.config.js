var webpack = require('webpack');
var CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
	entry: {
		js: [
			'./src/js/main.js'
		],
		style: [
			'./src/css/style.js'
		]
	},
	output: {
		path: __dirname + '/public/build/',
		publicPath: '/public/build/',
		filename: '[name].js'
	},
	module: {
		loaders: [
			{
				test: /\.js[x]?$/,
				loader: 'babel',
				query: {
					presets: ['es2015']
				}
			},
			{
				test: /\.less$/,
				loader: 'style!css!autoprefixer!less'
			},
			{
				test: /\.css$/,
				loader: 'style!css'
			},
			{
				test: /\.(jpg|png|woff|woff2|eot|ttf|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				loader: 'url?limit=8192&name=/img/[name].[ext]'
			}
		]
	},
	plugins: [
		new webpack.optimize.DedupePlugin(),
		new webpack.optimize.UglifyJsPlugin({
			compress: {
				warnings: false
			}
		}),
		new CopyWebpackPlugin([
            // {from: 'index.html', to: '../../View/ForgetPassword'}            
        ])
	]
}