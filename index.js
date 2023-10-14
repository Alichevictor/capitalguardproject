let dropper1 = document.getElementById("dropdown1").style.display;
let dropper2 = document.getElementById("dropdown2").style.display;
let dropper3 = document.getElementById("dropdown3").style.display;
let dropper4 = document.getElementById("dropdown4").style.display;
let dropper5 = document.getElementById("dropdown5").style.display;

function dropdown(num) {
  if (num === 1) {
    if (dropper1 === "block") {
      close();
    } else {
      close();
      document.getElementById("dropdown1").style.display = "block";
    }
  }
  if (num === 2) {
    if (dropper2 === "block") {
      close();
    } else {
      close();
      document.getElementById("dropdown2").style.display = "block";
    }
  }
  if (num === 3) {
    if (dropper3 === "block") {
      close();
    } else {
      close();
      document.getElementById("dropdown3").style.display = "block";
    }
  }
  if (num === 4) {
    if (dropper4 === "block") {
      close();
    } else {
      close();
      document.getElementById("dropdown4").style.display = "block";
    }
  }
  if (num === 5) {
    if (dropper5 === "block") {
      close();
    } else {
      close();
      document.getElementById("dropdown5").style.display = "block";
    }
  }
}

function close() {
  dropper1 = document.getElementById("dropdown1").style.display = "none";
  dropper2 = document.getElementById("dropdown2").style.display = "none";
  dropper3 = document.getElementById("dropdown3").style.display = "none";
  dropper4 = document.getElementById("dropdown4").style.display = "none";
  dropper5 = document.getElementById("dropdown5").style.display = "none";
}

function myFunction() {
  document.getElementById("dropdown1").classList.toggle("show");
}

startImageTransition();
 
        function startImageTransition() {
            var images = document.getElementsByClassName("test");
 
            for (var i = 0; i < images.length; ++i) {
                images[i].style.opacity = 1;
            }
 
            var top = 1;
 
            var cur = images.length - 1;
 
            setInterval(changeImage, 6000);
 
            async function changeImage() {
 
                var nextImage = (1 + cur) % images.length;
 
                images[cur].style.zIndex = top + 1;
                images[nextImage].style.zIndex = top;
 
                await transition();
 
                images[cur].style.zIndex = top;
 
                images[nextImage].style.zIndex = top + 1;
 
                top = top + 1;
 
                images[cur].style.opacity = 1;
               
                cur = nextImage;
 
            }
 
      function transition() {
                return new Promise(function(resolve, reject) {
                  var del = 0.04; 
 
                    var id = setInterval(changeOpacity, 10);
 
                    function changeOpacity() {
                        images[cur].style.opacity -= del;
                        if (images[cur].style.opacity <= 0) {
                            clearInterval(id);
                            resolve();
                        }
                    }
 
                })
            }
        }

        function toggleHeight() {
          var writeUpsDiv = document.getElementById('writeUps');
          var currentHeight = writeUpsDiv.offsetHeight;
        
          if (currentHeight === 10) {
            writeUpsDiv.style.height = '1150px'; // Set the desired open/unwrapped height
          } else {
            writeUpsDiv.style.height = '10px'; // Set the initial height
          }
        }

        function toggleHeight2() {
          var writeUpsDiv = document.getElementById('writeUps2');
          var currentHeight = writeUpsDiv.offsetHeight;
        
          if (currentHeight === 10) {
            writeUpsDiv.style.height = '400px'; // Set the desired open/unwrapped height
          } else {
            writeUpsDiv.style.height = '10px'; // Set the initial height
          }
        }
       

        
        function openz(num){
          if(num === 1){
            terminatez()
            document.getElementById("divi1").style.display="block";
          }else if(num === 2){
            terminatez()
            document.getElementById("divi2").style.display="block";
          }else if(num === 3){
            terminatez()
            document.getElementById("divi3").style.display="block";
        }}
        function terminatez() {
          document.getElementById("divi1").style.display = "none";
          document.getElementById("divi2").style.display = "none";
          document.getElementById("divi3").style.display = "none";
        }
    
        document.addEventListener('DOMContentLoaded', function() {
          var menuItems = document.querySelectorAll('#ul li');
        
          menuItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
              var currentItem = event.currentTarget;
        
              menuItems.forEach(function(menuItem) {
                menuItem.classList.remove('active');
              });
        
              currentItem.classList.add('active');
            });
          });
        });
        
        let mortgage1 = document.getElementById("mortgage1").style.display;
        let mortgage2 = document.getElementById("mortgage2").style.display;
        let mortgage3 = document.getElementById("mortgage3").style.display;
        let mortgage4 = document.getElementById("mortgage4").style.display;
        let mortgage5 = document.getElementById("mortgage5").style.display;
        let mortgage6 = document.getElementById("mortgage6").style.display;

        function mortgage(num){
          if(num === 1){
            terminatemortgage()
            document.getElementById("mortgage1").style.display="block"
          }else if(num === 2){
            terminatemortgage()
            document.getElementById("mortgage2").style.display="block"
          }else if(num === 3){
            terminatemortgage()
            document.getElementById("mortgage3").style.display="block"
          }else if(num === 4){
            terminatemortgage()
            document.getElementById("mortgage4").style.display="block"
          }else if(num === 5){
            terminatemortgage()
            document.getElementById("mortgage5").style.display="block"
          }else if(num === 6){
            terminatemortgage()
            document.getElementById("mortgage6").style.display="block"
          }
        }
        function terminatemortgage() {
          document.getElementById("mortgage1").style.display = "none";
          document.getElementById("mortgage2").style.display = "none";
          document.getElementById("mortgage3").style.display = "none";
          document.getElementById("mortgage4").style.display = "none";
          document.getElementById("mortgage5").style.display = "none";
          document.getElementById("mortgage6").style.display = "none";
        }


    


        