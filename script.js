
// function registerServiceWorker() {
//   if ('serviceWorker' in navigator) {
//     navigator.serviceWorker.register('ServiceWorker.js', { scope: '/' }).then(() => {
//       console.log('Service Worker registered successfully.');
//     }).catch(error => {
//       console.log('Service Worker registration failed:', error);
//     });
//   }
// }

window.addEventListener('DOMContentLoaded', ready);

var data, preview, output, array = [];
var parthList;
var curs = [
    [],
    [[], [], []],
    [[], [], []],
    [[], [], []],
    []
];

async function ready() {
    data = await fetch('./data.json').then(response => response.json());
    var input = document.querySelector('input[type="file"]');
    preview = document.querySelector('img');
    output = document.querySelector('#change material-list');
    parthList = document.querySelector('#curs section material-paper');

    input.addEventListener('change', getImage);
}

function getImage(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    var image;

    reader.onloadend = function () {
        image = reader.result;
        // preview.src = image;

        Quagga.decodeSingle({
            decoder: {
                readers: ["ean_reader", "code_128_reader"] // List of active readers
            },
            locate: true, // try to locate the barcode in the image
            src: image // '/test/fixtures/code_128/image-001.jpg' // or 'data:image/jpg;base64,' + data
        }, function (result) {
            console.log(result);
            if (!(result && result.codeResult && result.codeResult.code)) {
                alert("Не распозналось");
                return;
            }
            var tablet = data[result.codeResult.code]; // ["name"];
            if (!array.includes(tablet)) {
                array.push(tablet);


                var ingestion = tablet.ModeOfApplication.ingestion;
                var parth = tablet.ModeOfApplication.dayParth;
                for (let i = 0; i < parth.length; i++) {
                    if (parth[i] === 0) continue;
                    if ((i == 0) || (i == 4)) {
                        curs[i].push(tablet.name);
                    } else {
                        for (let j = 0; j < ingestion.length; j++) {
                            if (ingestion[i] === 0) continue;
                            curs[i][j].push(tablet.name);
                        }
                    }
                }
            }
            // alert(data[result.codeResult.code]["name"]);
            // console.log(data[result.codeResult.code]["ModeOfApplication"]);

            output.innerHTML = "";
            parthList.innerHTML = '';
            for (var i = 0; i < array.length; ++i) {
                var temp = document.createElement('medicine-list-item');
                temp.innerHTML = array[i].name;
                temp.src = array[i].src;
                // if (array[i].ModeOfApplication.dayParth[0] == 1) temp.style.background = '#b39ddb';
                // if (array[i].ModeOfApplication.dayParth[1] == 1) temp.style.background = 'red';
                // if (array[i].ModeOfApplication.dayParth[2] == 1) temp.style.background = 'red';
                // if (array[i].ModeOfApplication.dayParth[3] == 1) temp.style.background = 'red';
                // if (array[i].ModeOfApplication.dayParth[4] == 1) temp.style.background = 'red';
                output.appendChild(temp);
            }
            window.location.hash = 'change';

            var parthNames = ['натощак', 'за завтраком', 'днем', 'вечером', 'перед сном'];
            for (var i = 0; i < curs.length; i++) {
                if (curs[i].length === 0) continue; //Проверка на пустоту в массиве
                if ((i > 0) && (i < 4) && (curs[i][0] == 0) && (curs[i][1] == 0) && (curs[i][2] == 0)) continue;

                var parthTime = document.createElement('material-expand');
                parthTime.summary = parthNames[i];

                if ((i === 0) || (i === 4)) {
                    addNewParth(parthTime, curs[i]);
                } else {
                    addNewParthOnEat(parthTime, 'до еды', curs[i][0]);
                    addNewParthOnEat(parthTime, 'во время еды', curs[i][1]);
                    addNewParthOnEat(parthTime, 'после еды', curs[i][2]);
                };
                parthList.appendChild(parthTime);
            };

            if (result.codeResult) {
                console.log("result", result.codeResult.code);
            } else {
                console.log("not detected");
            }
        });
    }

    reader.readAsDataURL(file);
}

function addNewParth(root, parth) {
    var temp = document.createElement('medecine-curs');
    for (let j = 0; j < parth.length; j++) {
        var item = document.createElement('material-list-item');
        item.innerHTML = parth[j];
        temp.appendChild(item);
    }
    root.appendChild(temp);
};

function addNewParthOnEat(root, name, parth) {
    if (parth.length === 0) return; 
    const expand = document.createElement('material-expand');
    expand.summary = name;
    addNewParth(expand, parth);
    root.appendChild(expand);
}
