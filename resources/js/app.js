import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function removeClass(_elementsClass, _classToRemove){
    const arr = document.querySelectorAll(_elementsClass);
    Array.prototype.forEach.call(arr, function(el) {
        el.classList.remove(_classToRemove);
    });
}

function pageLoading(){
    const el = document.getElementById('loader-container');
    el.classList.add('loading');
}


document.getElementById("range-controller").onchange = function(){
    pageLoading();
    const el = document.getElementById("range-controller");
    window.location.href = el.dataset.route + '/' + el.value;
};

window.addEventListener('DOMContentLoaded', (event) => {
    const cmpNav = document.getElementsByClassName('cmp-nav');

    Array.prototype.forEach.call(cmpNav, function(el) {

        el.addEventListener('click', function (){

            removeClass('.cmp-canvas', 'active-canvas');
            const cmpCanvas = document.getElementById('cmp-' + el.dataset.id)
            cmpCanvas.classList.add('active-canvas');

            removeClass('.cmp-nav', 'btn-active');
            el.classList.add('btn-active');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })

    });

    const loaderEv = document.getElementsByClassName('loading-ev');
    Array.prototype.forEach.call(loaderEv, function(elm) {
        elm.addEventListener('click', function (){
            pageLoading()
        })
    })


});
