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
      duration: data.duration,
      slot_date : data.slot_date,
      prior_status : data.prior_status,
      created_by : data.created_by,
      auth_user_id : data.auth_user_id,
      auth_user_role : data.auth_user_role,
      slot_desc : data.slot_desc,
      slot_id : data.slot_id,
      encodeslot_id : data.encodeslot_id
    });
  });

socket.on('approve_slot', function(data) {
    io.sockets.emit( 'approve_slot', {
      start_time: data.start_time,
      end_time: data.end_time,
      department: data.department,
      duration: data.duration,
      slot_date : data.slot_date,
      slot_desc : data.slot_desc,
      prior_status : data.prior_status,
      created_by : data.created_by,
      status : data.status,
      auth_user_id : data.auth_user_id,
      auth_user_role : data.auth_user_role,
      slot_id : data.slot_id,
      encodeslot_id : data.encodeslot_id

    });
  });
});