window.addEventListener('orientationchange', function() {
    switch (window.orientation) {
      case -90:
      case 90:
        // alert('landscape');
        $('#accordionSidebar').removeClass("toggled");
        $('#sidebarToggleTop').css("display", "");
        $('#nav-mobile').css("display", "none")
        $('#ola').css("display", "none")
        break;
      default:
        // alert('portrait');
        // $('#accordionSidebar').addClass("toggled");
        $('#accordionSidebar').removeClass("toggled");
        $('#sidebarToggleTop').css("display", "none");
        $('#nav-mobile').css("display", "")
        $('#ola').css("display", "")
        break;
    }
  });