function keyPressed(evt) {
  var F5 = 116;
  if(document.layers) {
            if (evt.which == F5) {
             return false;
          }
  }else if(document.all){
         if (event.keyCode == F5) {
              event.keyCode = 0;
               window.event.returnValue = false;
            }
  }
}

function click(e) {
    if (document.all) {
         if (event.button == 2) {
              alert("版权所有请勿复制");
              return false;
         }
    }
    if (document.layers) {
         if (e.which == 3) {
              alert("版权所有请勿复制");
              return false;
         }
    }
}

if(document.layers){
    window.captureEvents (Event.KEYDOWN);
    document.captureEvents(Event.MOUSEDOWN);
    window.onkeydown=keyPressed;
    window.onmousedown=click;
}else{
    document.onkeydown=keyPressed;
    document.onmousedown=click;
}