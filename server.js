var http = require('http').Server();
var io = require('socket.io')(http);
var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('temperature.update', function(err, count) {
    console.log('here');
});
redis.on('message', function (channel, message){
    console.log('Message received!!=>', message);
    console.log('Chanel=>', channel);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen( 4000, function() {
    console.log('listening !')
})
