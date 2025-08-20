document
  .getElementById("hamburger--dashboard")
  .addEventListener("click", function () {
    document.getElementById("responsive--dashboard").style.left = "-40px";
    document.getElementById("hamburger--dashboard").style.display = "none";
    document.getElementById("close--menu--dashboard").style.display = "block";
  });
document
  .getElementById("close--menu--dashboard")
  .addEventListener("click", function () {
    document.getElementById("responsive--dashboard").style.left = "-100%";
    document.getElementById("close--menu--dashboard").style.display = "none";
    document.getElementById("hamburger--dashboard").style.display = "block";
  });

//Update the music card text:
function updateMusicTitle() {
  const screenWidth = window.innerWidth;
  const musicTitleElements = document.querySelectorAll(".producer h4");
  const addPackMusicTitles = document.querySelectorAll(
    ".producer .add-pack-title"
  );
  musicTitleElements.forEach((musicTitleElement) => {
    const originalTitle = musicTitleElement.textContent;
    if (screenWidth > 319 && screenWidth <= 374) {
      
    } else if (screenWidth > 479 && screenWidth <= 568) {
      const updatedTitle = originalTitle.slice(0, 35) + "...";
      musicTitleElement.textContent = updatedTitle;
    } else if (screenWidth > 568 && screenWidth <= 675) {
      const updatedTitle = originalTitle.slice(0, 45) + "...";
      musicTitleElement.textContent = updatedTitle;
    } else {
      musicTitleElement.textContent = originalTitle;
    }
  });
  addPackMusicTitles.forEach((musicTitle) => {
    const originalTitle = musicTitle.textContent;
    if (screenWidth > 319 && screenWidth < 433) {
      console.log(originalTitle);
    }
  });
}
updateMusicTitle();
window.addEventListener("resize", updateMusicTitle);
