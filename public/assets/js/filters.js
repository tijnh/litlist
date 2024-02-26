const audiobookCheckboxes = document.querySelectorAll(".audiobook-checkbox");
const readingLevelCheckboxes = document.querySelectorAll(".reading-level-checkbox");
const themeCheckboxes = document.querySelectorAll(".theme-checkbox");

addCheckBoxStyling(audiobookCheckboxes, ".audiobook-checkbox");
addCheckBoxStyling(readingLevelCheckboxes, ".reading-level-checkbox");
addCheckBoxStyling(themeCheckboxes, ".theme-checkbox");

function addCheckBoxStyling(checkboxes, cssClass) {
  markCheckedBoxes(cssClass);

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
      markCheckedBoxes(cssClass);
    });
  })
}

function markCheckedBoxes(cssClass) {
  let boxes = document.querySelectorAll(cssClass);

  if (allBoxesUnchecked(boxes)) {
    boxes.forEach((box) => {
      findLableForControl(box).classList.remove("checkbox-unchecked");
      findLableForControl(box).classList.remove("checkbox-checked");
    });

  } else {
    boxes.forEach((box) => {
      if (box.checked) {
        findLableForControl(box).classList.remove("checkbox-unchecked");
        findLableForControl(box).classList.add("checkbox-checked");
      } else {
        findLableForControl(box).classList.remove("checkbox-checked");
        findLableForControl(box).classList.add("checkbox-unchecked");
      }
    });

  }
}

function allBoxesUnchecked(boxes) {
  for (let box of boxes) {
    if (box.checked) {
      return false;
    }
  }
  return true;
}

function findLableForControl(el) {
  var idVal = el.id;
  labels = document.getElementsByTagName('label');
  for (var i = 0; i < labels.length; i++) {
    if (labels[i].htmlFor == idVal)
      return labels[i];
  }
}