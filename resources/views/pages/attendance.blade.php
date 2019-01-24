@extends('layouts.app') 
@section('content')

<div class="container" style="text-align: center">
  <br>
  <br>
  <canvas id="canvas" hidden></canvas>
  <p class="lead">
    <i class="fa fa-camera"></i>
    Show your ID card at the CAM
  </p>
</div>

<script src="{{asset('js/jsQR.js')}}"></script>
<script>
  window.onload = function(){

      var video = document.createElement("video");
      var canvasElement = document.getElementById("canvas");
      var canvas = canvasElement.getContext("2d");
      var stopProcessing = false;
      var roll_no = null;
  
      function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
      }
  
      navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.play();
        requestAnimationFrame(tick);
      });
  
      function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
          canvasElement.hidden = false;
  
          canvasElement.height = video.videoHeight;
          canvasElement.width = video.videoWidth;
          canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
          var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
          var code = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: "dontInvert",
          });
          if (code) {

            // QR scan complete
            console.log(code);
            roll_no = code.data;
            stopProcessing = true;
            takeAttendance();

            drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
            drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
            drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
            drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
          } else {
          }
        }
        if(stopProcessing) return;
        requestAnimationFrame(tick);
      }

      function takeAttendance(){
        $.ajax({
          method: 'POST',
          url: '/api/take-attendance',
          data: {
            roll_no: roll_no
          }
        })
        .done(function(data){
          Swal.fire('Success', data, 'success')
          .then(()=>{
            location.reload();
          });
          
        });
      }
    }
</script>

@stop