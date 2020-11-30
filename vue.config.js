module.exports = {
    css: {
        loaderOptions: {
            // pass options to sass-loader
            sass: {
                // @/ is an alias to src/
                // so this assumes you have a file named `src/variables.scss`
                additionalData: `@import "@/scss/global.scss";`
            }
        }
    },
    chainWebpack: config => {
        if(config.plugins.has('extract-css')) {
            const extractCSSPlugin = config.plugin('extract-css')
            extractCSSPlugin && extractCSSPlugin.tap(() => [{
                filename: '[name].css',
                chunkFilename: '[name].css'
            }])
        }
    },
    configureWebpack: {
        output: {
            filename: '[name].js',
            chunkFilename: '[name].js'
        }
    }
};
