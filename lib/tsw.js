"use strict";

function tswOnLoadMain() {
    console.log('Loading The SEO Workspace view..');
}

// Starts all JS..
window.addEventListener('load', () => {
    if (typeof weAreInTheSeoWorkspace !== 'undefined') {
        tswOnLoadMain();
    }
});
