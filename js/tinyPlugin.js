(function()  {
   // Create a new plugin class
   tinymce.create('tinymce.plugins.ExamplePlugin', {
   createControl: function(n, cm) {
       switch (n) {
           case 'tinyPlugin':
               var mlb = cm.createListBox('tinyPlugin', {
                    title : 'TOC Levels',
                    onselect : function(v) {
                        var content = tinyMCE.activeEditor.selection.getContent({format : 'text'});
                        tinyMCE.activeEditor.selection.setContent('[tinytoc level="' + v + '"]' + content + '[/tinytoc]');
                    }
               });

               // Add some values to the list box
                mlb.add('Level 1', '1');
                mlb.add('Level 2', '2');
                mlb.add('Level 3', '3');

		        // Return the new listbox instance
		        return mlb;
	        }

	        return null;
	    }

    });

    // Register plugin with a short name
    tinymce.PluginManager.add('tinyPlugin', tinymce.plugins.ExamplePlugin);
})();

