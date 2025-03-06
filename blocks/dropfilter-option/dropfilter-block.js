wp.blocks.registerBlockType('custom/dropfilter-option-block', {
    title: 'Dropfilter Option Block',
    icon: 'admin-appearance',
    category: 'yacht-manager',

    edit: function () {

        return (
            wp.element.createElement('div', { className: 'custom-dropfilter-block' },
                wp.element.createElement('h3', { className: 'dropfilter-label' },
                    'The Yacht dropdown filter'
                ),
                wp.element.createElement('p', { className: 'dropfilter-text' },
                    'Enables dropfilter option to find yacht'
                ),
            )
        );
    },

    save: function () {
        return null; // Server-side rendering only
    }
});