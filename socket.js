var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis(6379, '127.0.0.1');

redis.psubscribe('*', function(err, count) {

})

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    console.log(channel, message);
    io.emit(channel + '[' + message.event + ']', message.data);
    io.emit(channel, message.data);
})

http.listen(6378, function () {
    console.log('Server runned');
});