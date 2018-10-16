
function registerServiceWorker() {
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('ServiceWorker.js', { scope: '/' }).then(() => {
      console.log('Service Worker registered successfully.');
    }).catch(error => {
      console.log('Service Worker registration failed:', error);
    });
  }
}

window.addEventListener('DOMContentLoaded', ready);

async function ready() {
  var data = await fetch('./data.json').then(response => response.json());
  var input = document.querySelector('input[type="file"]');
  var preview = document.querySelector('img');
  var output = document.querySelector('pre');

  input.addEventListener('change', getImage);

  function getImage(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    var image;

    reader.onloadend = function () {
      image = reader.result;
      preview.src = image;

      Quagga.decodeSingle({
            decoder: {
                readers: ["ean_reader", "code_128_reader"] // List of active readers
            },
            locate: true, // try to locate the barcode in the image
            src: image // '/test/fixtures/code_128/image-001.jpg' // or 'data:image/jpg;base64,' + data
        }, function(result){
            console.log(result);
            if (!(result && result.codeResult && result.codeResult.code)) {
              output.innerText = "Не распозналось";
              return;
            }
            // output.innerText = result.codeResult.code; // JSON.stringify(result, null, 2);
            output.innerText = result.codeResult.code + '\n\n' + JSON.stringify(data[result.codeResult.code], null, 2);
            if(result.codeResult) {
                console.log("result", result.codeResult.code);
            } else {
                console.log("not detected");
            }
        });
    }

    reader.readAsDataURL(file);
  }

}
