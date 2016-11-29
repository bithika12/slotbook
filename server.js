var socket  = require( './public/node_modules/socket.io' );
var express = require('./public/node_modules/express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {
socket.on('new_slot', function(data) {
    io.sockets.emit( 'new_slot', {
    	start_time: data.start_time,
    	end_time: data.end_time,
    	department: data.department,
    	duration: data.duration
    });
  });
});