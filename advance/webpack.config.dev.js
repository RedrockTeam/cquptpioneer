var webpack = require('webpack');

module.exports = {
	plugins: [
		// new webpack.HotModuleReplacementPlugin()
	],
	entry: {
		js: [
			'webpack/hot/only-dev-server',
			'webpack-dev-server/client?http://localhost:8080',
			'./src/js/main.js'
		],
		style: [
			'webpack/hot/only-dev-server',
			'webpack-dev-server/client?http://localhost:8080',
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
	}
}