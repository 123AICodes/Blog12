
const nav = document.querySelector('nav'),
  navItems = document.querySelector('nav .nav__items'),
  openNavBtn = document.querySelector('.open__nav-btn'),
  closeNavBtn = document.querySelector('.close__nav-btn'),
  aside = document.querySelector('.dashboard aside'),
  showSideBar = document.querySelector('.dashboard #show__sidebar-btn'),
  hideSideBar = document.querySelector('.dashboard #hide__sidebar-btn');

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
 ***dashboard sidebar
*/
showSideBar.addEventListener('click', () => {
  aside.style.left = "0";
  showSideBar.style.display = "none";
  hideSideBar.style.display = "inline-block";
});
hideSideBar.addEventListener('click', () => {
  aside.style.left = "-100%";
  hideSideBar.style.display = "none";
  showSideBar.style.display = "inline-block";
});



