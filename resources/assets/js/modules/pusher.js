var io = require('socket.io-client')

module.exports = {
    host: null,
    io: null,
    _init (host) {
        this.host = host

        if(_.isString(this.host)) {
            this.io = io(this.host)
        }
    },
    on (chanel, event, callback) {
        if(!_.isObject(this.io)) {
            return this
        }

        if(arguments.length === 2 && _.isFunction(event)) {
            this.io.on(chanel, event)
            return this
        }

        this.io.on(chanel+'['+event+']', callback)
        return this
    }
}