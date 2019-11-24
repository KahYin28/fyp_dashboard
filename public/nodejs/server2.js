var express = require('express'),
    http = require('http'),
    server = http.createServer(app);

var app = express();

const redis = require('ioredis');
const io = require('socket.io');
const client = redis.createClient();

server.listen(4000, 'localhost');
console.log("Listening.....");

io.listen(server).on('connection', function (client) {
    const redisClient = redis.createClient();
  //  console.log(redisClient);
    redisClient.subscribe('temperature.update');
    console.log(redisClient);
    console.log("Redis server running.....");

   redisClient.on("message", function (channel, message) {
      //  console.log(message);
        client.emit('temperature.update', ['sadasdasdsad']);
   });

    client.on('disconnect', function () {
        redisClient.quit();
    });
});
