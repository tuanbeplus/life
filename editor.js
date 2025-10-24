wp.blocks.registerBlockStyle('core/button', {
  name: 'orange-button',
  label: 'Orange',
});

wp.blocks.registerBlockStyle('core/button', {
  name: 'black-button',
  label: 'Black',
});

wp.blocks.registerBlockStyle('core/button', {
  name: 'grey-button',
  label: 'Grey',
});

wp.domReady( function() {
  wp.blocks.getBlockTypes().forEach((block) => {
    if (_.isArray(block['styles'])) {
      console.log(block.name, _.pluck(block['styles'], 'name'));
    }
  });
  wp.blocks.unregisterBlockStyle('core/button', 'fill');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
});