<style>
.badge{
  display: inline-block;
  padding: .25em .4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25rem;
}
.badge-danger{
  color: rgb(255, 255, 255);
  background-color: rgb(220, 53, 69);
}
.badge-info {
  color: rgb(255, 255, 255);
  background-color: rgb(23, 162, 184);
}
</style>
<?php if( get_option('DEVELOPMENT_MODE') == TRUE): ?>
  <strong>STATUS:</strong> <span class="badge badge-danger">DEVELOPMENT MODE</span>
<?php else: ?>
  <strong>STATUS:</strong> <span class="badge badge-info">LIVE</span>
<?php endif; ?>
