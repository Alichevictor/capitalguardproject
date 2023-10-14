let divz =  document.getElementById("first").style.display;
let divs=  document.getElementById("second").style.display;

function opennew(diva){

 if(diva === 1){
   terminate2()
   document.getElementById("first").style.display="block";
 }else if(diva === 2){
   terminate2()
   document.getElementById("second").style.display="block";
 }
}
function terminate2() {
 document.getElementById("first").style.display= "none";
 document.getElementById("second").style.display= "none";
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


  function toggleHeight3() {
    var writeUpsDiv = document.getElementById('writeUps3');
    var currentHeight = writeUpsDiv.offsetHeight;
  
    if (currentHeight === 10) {
      writeUpsDiv.style.height = '750px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv.style.height = '10px'; // Set the initial height
    }
  }


 
  function toggleHeight4() {
    var writeUpsDiv = document.getElementById('writeUps4');
    var currentHeight = writeUpsDiv.offsetHeight;
  
    if (currentHeight === 10) {
      writeUpsDiv.style.height = '3700px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv.style.height = '10px'; // Set the initial height
    }
  }

  function toggleHeight5() {
    var writeUpsDiv = document.getElementById('writeUps5');
    var currentHeight = writeUpsDiv.offsetHeight;
  
    if (currentHeight === 10) {
      writeUpsDiv.style.height = '3300px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv.style.height = '10px'; // Set the initial height
    }
  }
  function toggleHeight6() {
    var writeUpsDiv = document.getElementById('writeUps6');
    var currentHeight = writeUpsDiv.offsetHeight;
  
    if (currentHeight === 10) {
      writeUpsDiv.style.height = '2900px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv.style.height = '10px'; // Set the initial height
    }
  }


  function openup(num) {
    var writeUpsDiv1 = document.getElementById('div1');
    var writeUpsDiv2 = document.getElementById('div2');
    var writeUpsDiv3 = document.getElementById('div3');
    var writeUpsDiv4 = document.getElementById('div4');
    var writeUpsDiv5 = document.getElementById('div5');
    var currentHeight1 = writeUpsDiv1.offsetHeight;
    var currentHeight2 = writeUpsDiv2.offsetHeight;
    var currentHeight3 = writeUpsDiv3.offsetHeight;
    var currentHeight4 = writeUpsDiv4.offsetHeight;
    var currentHeight5 = writeUpsDiv5.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
      writeUpsDiv1.style.height = '50px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv1.style.height = '0px'; // Set the initial height
    }

if(num === 2 && currentHeight2 === 0 ){
    writeUpsDiv2.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv2.style.height = '0px'; // Set the initial height
  }

if(num === 3 && currentHeight3 === 0){
    writeUpsDiv3.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv3.style.height = '0px'; // Set the initial height
  }

if(num === 4 && currentHeight4 === 0){
    writeUpsDiv4.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv4.style.height = '0px'; // Set the initial height
  }

if(num === 5 && currentHeight5 === 0){
    writeUpsDiv5.style.height = '50px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv5.style.height = '0px'; // Set the initial height
  }

  }

    
  function openup2(num) {
    var writeUpsDiv1 = document.getElementById('divz1');
    var writeUpsDiv2 = document.getElementById('divz2');
    var writeUpsDiv3 = document.getElementById('divz3');
    var writeUpsDiv4 = document.getElementById('divz4');
    var writeUpsDiv5 = document.getElementById('divz5');
    var currentHeight1 = writeUpsDiv1.offsetHeight;
    var currentHeight2 = writeUpsDiv2.offsetHeight;
    var currentHeight3 = writeUpsDiv3.offsetHeight;
    var currentHeight4 = writeUpsDiv4.offsetHeight;
    var currentHeight5 = writeUpsDiv5.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
      writeUpsDiv1.style.height = '500px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv1.style.height = '0px'; // Set the initial height
    }

if(num === 2 && currentHeight2 === 0 ){
    writeUpsDiv2.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv2.style.height = '0px'; // Set the initial height
  }

if(num === 3 && currentHeight3 === 0){
    writeUpsDiv3.style.height = '800px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv3.style.height = '0px'; // Set the initial height
  }

if(num === 4 && currentHeight4 === 0){
    writeUpsDiv4.style.height = '140px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv4.style.height = '0px'; // Set the initial height
  }

if(num === 5 && currentHeight5 === 0){
    writeUpsDiv5.style.height = '140px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv5.style.height = '0px'; // Set the initial height
  }

  }

  
  function openup(num) {
    var writeUpsDiv1 = document.getElementById('div1');
    var writeUpsDiv2 = document.getElementById('div2');
    var writeUpsDiv3 = document.getElementById('div3');
    var writeUpsDiv4 = document.getElementById('div4');
    var writeUpsDiv5 = document.getElementById('div5');
    var currentHeight1 = writeUpsDiv1.offsetHeight;
    var currentHeight2 = writeUpsDiv2.offsetHeight;
    var currentHeight3 = writeUpsDiv3.offsetHeight;
    var currentHeight4 = writeUpsDiv4.offsetHeight;
    var currentHeight5 = writeUpsDiv5.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
      writeUpsDiv1.style.height = '50px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv1.style.height = '0px'; // Set the initial height
    }

if(num === 2 && currentHeight2 === 0 ){
    writeUpsDiv2.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv2.style.height = '0px'; // Set the initial height
  }

if(num === 3 && currentHeight3 === 0){
    writeUpsDiv3.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv3.style.height = '0px'; // Set the initial height
  }

if(num === 4 && currentHeight4 === 0){
    writeUpsDiv4.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv4.style.height = '0px'; // Set the initial height
  }

if(num === 5 && currentHeight5 === 0){
    writeUpsDiv5.style.height = '50px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv5.style.height = '0px'; // Set the initial height
  }

  }

    
  function openup3(num) {
    var writeUpsDiv1 = document.getElementById('divs1');
    var writeUpsDiv2 = document.getElementById('divs2');
    var writeUpsDiv3 = document.getElementById('divs3');
    var writeUpsDiv4 = document.getElementById('divs4');
    var writeUpsDiv5 = document.getElementById('divs5');
    var writeUpsDiv6 = document.getElementById('divs6');
    var writeUpsDiv7 = document.getElementById('divs7');
    var currentHeight1 = writeUpsDiv1.offsetHeight;
    var currentHeight2 = writeUpsDiv2.offsetHeight;
    var currentHeight3 = writeUpsDiv3.offsetHeight;
    var currentHeight4 = writeUpsDiv4.offsetHeight;
    var currentHeight5 = writeUpsDiv5.offsetHeight;
    var currentHeight6 = writeUpsDiv6.offsetHeight;
    var currentHeight7 = writeUpsDiv7.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
      writeUpsDiv1.style.height = '200px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv1.style.height = '0px'; // Set the initial height
    }

if(num === 2 && currentHeight2 === 0 ){
    writeUpsDiv2.style.height = '210px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv2.style.height = '0px'; // Set the initial height
  }

if(num === 3 && currentHeight3 === 0){
    writeUpsDiv3.style.height = '100px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv3.style.height = '0px'; // Set the initial height
  }

if(num === 4 && currentHeight4 === 0){
    writeUpsDiv4.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv4.style.height = '0px'; // Set the initial height
  }

if(num === 5 && currentHeight5 === 0){
    writeUpsDiv5.style.height = '270px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv5.style.height = '0px'; // Set the initial height
  }
  if(num === 6 && currentHeight6 === 0){
    writeUpsDiv6.style.height = '80px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv6.style.height = '0px'; // Set the initial height
  }
  if(num === 7 && currentHeight7 === 0){
    writeUpsDiv7.style.height = '80px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv7.style.height = '0px'; // Set the initial height
  }

  }

  function openup4(num) {
    var writeUpsDiv1 = document.getElementById('divo1');
    var writeUpsDiv2 = document.getElementById('divo2');
    var writeUpsDiv3 = document.getElementById('divo3');
    var writeUpsDiv4 = document.getElementById('divo4');
    var writeUpsDiv5 = document.getElementById('divo5');
    var writeUpsDiv6 = document.getElementById('divo6');
    var writeUpsDiv7 = document.getElementById('divo7');
    var currentHeight1 = writeUpsDiv1.offsetHeight;
    var currentHeight2 = writeUpsDiv2.offsetHeight;
    var currentHeight3 = writeUpsDiv3.offsetHeight;
    var currentHeight4 = writeUpsDiv4.offsetHeight;
    var currentHeight5 = writeUpsDiv5.offsetHeight;
    var currentHeight6 = writeUpsDiv6.offsetHeight;
    var currentHeight7 = writeUpsDiv7.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
      writeUpsDiv1.style.height = '500px'; // Set the desired open/unwrapped height
    } else {
      writeUpsDiv1.style.height = '0px'; // Set the initial height
    }

if(num === 2 && currentHeight2 === 0 ){
    writeUpsDiv2.style.height = '150px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv2.style.height = '0px'; // Set the initial height
  }

if(num === 3 && currentHeight3 === 0){
    writeUpsDiv3.style.height = '100px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv3.style.height = '0px'; // Set the initial height
  }

if(num === 4 && currentHeight4 === 0){
    writeUpsDiv4.style.height = '70px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv4.style.height = '0px'; // Set the initial height
  }

if(num === 5 && currentHeight5 === 0){
    writeUpsDiv5.style.height = '100px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv5.style.height = '0px'; // Set the initial height
  }
  if(num === 6 && currentHeight6 === 0){
    writeUpsDiv6.style.height = '80px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv6.style.height = '0px'; // Set the initial height
  }
  if(num === 7 && currentHeight7 === 0){
    writeUpsDiv7.style.height = '100px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv7.style.height = '0px'; // Set the initial height
  }

  }



  

document.getElementById('loanForm').addEventListener('submit', function (event) {
  event.preventDefault();
  const loanAmount = parseFloat(document.getElementById('loanAmount').value);
  const numMonths = parseInt(document.getElementById('numMonths').value);

  const loanDetails = calculateLoanDetails(loanAmount, numMonths);

  const resultsDiv = document.getElementById('results');
  resultsDiv.innerHTML = `
    <p>Total loan amount + interest: $${loanDetails.totalAmountWithInterest.toFixed(2)}</p>
    <p>Total interest on the loan: $${loanDetails.totalInterest.toFixed(2)}</p>
    <p>Monthly repayment: $${loanDetails.monthlyRepayment.toFixed(2)}</p>
  `;
});


function openza(num) {
  var writeUpsDiv1 = document.getElementById('open1');
  var writeUpsDiv2 = document.getElementById('open2');
  var writeUpsDiv3 = document.getElementById('open3');
  var writeUpsDiv4 = document.getElementById('open4');
  var writeUpsDiv5 = document.getElementById('open5');
  var writeUpsDiv6 = document.getElementById('open6');
  var writeUpsDiv7 = document.getElementById('open7');
  var writeUpsDiv8 = document.getElementById('open8');
  var writeUpsDiv9 = document.getElementById('open9');
  var writeUpsDiv10 = document.getElementById('open10');
  var currentHeight1 = writeUpsDiv1.offsetHeight;
  var currentHeight2 = writeUpsDiv2.offsetHeight;
  var currentHeight3 = writeUpsDiv3.offsetHeight;
  var currentHeight4 = writeUpsDiv4.offsetHeight;
  var currentHeight5 = writeUpsDiv5.offsetHeight;
  var currentHeight6 = writeUpsDiv6.offsetHeight;
  var currentHeight7 = writeUpsDiv7.offsetHeight;
  var currentHeight8 = writeUpsDiv8.offsetHeight;
  var currentHeight9 = writeUpsDiv9.offsetHeight;
  var currentHeight10 = writeUpsDiv10.offsetHeight;
if(num === 1 && currentHeight1 === 0 ){
    writeUpsDiv1.style.height = '200px'; // Set the desired open/unwrapped height
  } else {
    writeUpsDiv1.style.height = '0px'; // Set the initial height
  }

if(num === 2 && currentHeight2 === 0 ){
  writeUpsDiv2.style.height = '150px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv2.style.height = '0px'; // Set the initial height
}

if(num === 3 && currentHeight3 === 0){
  writeUpsDiv3.style.height = '300px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv3.style.height = '0px'; // Set the initial height
}

if(num === 4 && currentHeight4 === 0){
  writeUpsDiv4.style.height = '1000px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv4.style.height = '0px'; // Set the initial height
}

if(num === 5 && currentHeight5 === 0){
  writeUpsDiv5.style.height = '300px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv5.style.height = '0px'; // Set the initial height
}
if(num === 6 && currentHeight6 === 0){
  writeUpsDiv6.style.height = '200px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv6.style.height = '0px'; // Set the initial height
}
if(num === 7 && currentHeight7 === 0){
  writeUpsDiv7.style.height = '220px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv7.style.height = '0px'; // Set the initial height
}
if(num === 8 && currentHeight8 === 0){
  writeUpsDiv8.style.height = '300px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv8.style.height = '0px'; // Set the initial height
}
if(num === 9  && currentHeight9 === 0){
  writeUpsDiv9.style.height = '400px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv9.style.height = '0px'; // Set the initial height
}
if(num === 10 && currentHeight10 === 0){
  writeUpsDiv10.style.height = '1000px'; // Set the desired open/unwrapped height
} else {
  writeUpsDiv10.style.height = '0px'; // Set the initial height
}

}

        let div1 = document.getElementById("div11").style.display;
        let div2 = document.getElementById("div22").style.display;
        let div3 = document.getElementById("div33").style.display;
        let div4 = document.getElementById("div44").style.display;
  

        function openli(num){
          if(num === 1){
            terminate();
            document.getElementById("div11").style.display="block";
          }else if(num === 2){
            terminate();
            document.getElementById("div22").style.display="block";
          }else if(num === 3){
            terminate();
            document.getElementById("div33").style.display="block";
          }else if(num === 4){
            terminate();
            document.getElementById("div44").style.display="block";
          }
        }
        function terminate() {
          document.getElementById("div11").style.display = "none";
          document.getElementById("div22").style.display = "none";
          document.getElementById("div33").style.display = "none";
          document.getElementById("div44").style.display = "none";
        }


        function smallscreen(num) {
          var writeUpsDiv1 = document.getElementById('smalla1');
          var writeUpsDiv2 = document.getElementById('smalla2');
          var writeUpsDiv3 = document.getElementById('smalla3');
          var writeUpsDiv4 = document.getElementById('smalla4');
          var writeUpsDiv5 = document.getElementById('smalla5');
          var currentHeight1 = writeUpsDiv1.offsetHeight;
          var currentHeight2 = writeUpsDiv2.offsetHeight;
          var currentHeight3 = writeUpsDiv3.offsetHeight;
          var currentHeight4 = writeUpsDiv4.offsetHeight;
          var currentHeight5 = writeUpsDiv5.offsetHeight;
      if(num === 1 && currentHeight1 === 0 ){
            writeUpsDiv1.style.height = '850px'; // Set the desired open/unwrapped height
          } else {
            writeUpsDiv1.style.height = '0px'; // Set the initial height
          }
      
      if(num === 2 && currentHeight2 === 0 ){
          writeUpsDiv2.style.height = '850px'; // Set the desired open/unwrapped height
        } else {
          writeUpsDiv2.style.height = '0px'; // Set the initial height
        }
      
      if(num === 3 && currentHeight3 === 0){
          writeUpsDiv3.style.height = '400px'; // Set the desired open/unwrapped height
        } else {
          writeUpsDiv3.style.height = '0px'; // Set the initial height
        }
      
      if(num === 4 && currentHeight4 === 0){
          writeUpsDiv4.style.height = '550px'; // Set the desired open/unwrapped height
        } else {
          writeUpsDiv4.style.height = '0px'; // Set the initial height
        }
      
      if(num === 5 && currentHeight5 === 0){
          writeUpsDiv5.style.height = '450px'; // Set the desired open/unwrapped height
        } else {
          writeUpsDiv5.style.height = '0px'; // Set the initial height
        }
      
        }
      
      


function openNav() {
  document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

