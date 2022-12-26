
const nav = document.querySelector('nav'),
  navItems = document.querySelector('nav .nav__items'),
  openNavBtn = document.querySelector('.open__nav-btn'),
  closeNavBtn = document.querySelector('.close__nav-btn');

/**
* header
*/
window.onscroll = () => {
  nav.classList.toggle('active', window.scrollY > 0);
};
/**
* navbar
*/
openNavBtn.addEventListener('click', () => {
  navItems.style.display = "flex";
  openNavBtn.style.display = "none";
  closeNavBtn.style.display = "inline-block";
});
closeNavBtn.addEventListener('click', () => {
  navItems.style.display = "none";
  closeNavBtn.style.display = "none";
  openNavBtn.style.display = "inline-block";
});
/**
***load more button
*/
let loadMoreBtn = document.querySelector(".posts .load__more-btn");
let currentItem = 3;

loadMoreBtn.onclick = () => {
  let boxes = [...document.querySelectorAll('.post')];
  for (var i = currentItem; i < currentItem + 3; i++) {
    boxes[i].style.display = 'inline-block';
  };
  currentItem += 3;
  if (currentItem >= boxes.length) {
    loadMoreBtn.style.display = 'none';
  };
};




