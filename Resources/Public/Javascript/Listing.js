const paginateLinks = document.querySelectorAll(".paginate");
var products = document.querySelector('.product-items');
var paginationClass = document.querySelector(".pagination-load-wrap");
var loader = document.querySelector(".product-loader");
var searchField = document.getElementById("search_input");
var searchSelect = document.getElementById("search_select");
var resetButton = document.getElementById("reset");
console.log(searchSelect.value)
console.log(searchField.value)

const paginate = function(event) {
    let url = this.getAttribute("href");
    if(paginateLinks.length != 1) {
        products.innerHTML = '';
    }
    // Show loader
    loader.classList.remove('d-none');
    event.preventDefault();
    fetch(url, {
            method: 'GET',
        }).then((resp) => {
            return resp.text();
        }).then((html) => {

            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");

            // Hide loader
            loader.classList.add('d-none');

            // Get the new items
            let filterProducts = doc.querySelector('.product-items').innerHTML;
            // Render the items
            products.innerHTML += filterProducts;

            // Get pagiantion section
            let pagination = doc.querySelector('.pagination-load-wrap').innerHTML;
            // Replace new HTML
            paginationClass.innerHTML = pagination;

            // Assign click event
            let pageBtns = paginationClass.querySelectorAll('.paginate');
            if(pageBtns.length > 0) {
                for (let j = 0; j < pageBtns.length; j++) {
                    pageBtns[j].addEventListener('click', paginate, false);

                }
            }
        }).catch((error) => {
        });

};

if(paginateLinks.length > 0) {
    for (let i = 0; i < paginateLinks.length; i++) {
        paginateLinks[i].addEventListener('click', paginate, false);

    }
}

resetButton.addEventListener('click',()=> {
  window.location.href = window.location.href
});
