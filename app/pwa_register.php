<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/app/sw.js', {scope: '/app/'});
  });
}
</script>
