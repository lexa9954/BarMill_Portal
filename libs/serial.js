var fs = require('fs')
, http = require('http')
, socketio = require('socket.io')
, com = require("serialport");

var WebSocketServer = require('websocket').server;

// create the server
var wsServer = new WebSocketServer({
httpServer: http.createServer().listen(1337)
});

var serialPort = new com.SerialPort("COM4", {
baudrate: 1200,
dataBits: 7,
parity: 'none',
stopBits: 1,
parser: com.parsers.readline('\r\n')
});

wsServer.on('request', function(request) {

var connection = request.accept(null, request.origin);
serialPort.on('data', function(data) {
        //console.log('Received Message: ' + data);
        fs.writeFile("data.txt", data, function(err) {
            if(err) {
                return console.log(err);
            }
        });
        connection.sendUTF(data);
});
});