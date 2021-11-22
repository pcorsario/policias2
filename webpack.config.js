const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '--': path.resolve('resources/scss'),
        },
    },
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]'
    }
};
