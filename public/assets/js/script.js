// form repeater
$(document).ready(function () {
  $(".repeater").repeater({
    initEmpty: false,
    defaultValues: {
      "text-input": "",
    },
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      $(this).slideUp(deleteElement);
      setTimeout(() => {
        generateCV();
      }, 500);
    },
    isFirstItemUndeletable: true,
  });

  // Preload skills if available
  const preloadSkills =
    "<?php if (isset($id)) { echo addslashes($skills); } ?>";
  if (preloadSkills) {
    const skillsArray = preloadSkills.split(",").map((s) => s.trim());
    const repeater = $('.repeater[data-repeater-list="group-e"]');
    repeater.setList(skillsArray.map((skill) => ({ skill })));
  }
});
