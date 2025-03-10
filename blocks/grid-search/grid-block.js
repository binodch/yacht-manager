wp.blocks.registerBlockType('custom/grid-search-block', {
    title: 'Grid Search Block',
    icon: 'admin-appearance',
    category: 'yacht-manager',

    attributes: {
        title: { type: 'string', default: '' },
        description: { type: 'string', default: '' },
    },

    edit: function (props) {
        function updateTitle(event) {
            props.setAttributes({ title: event.target.value });
        }

        return (
            wp.element.createElement('div', { className: 'custom-grid-search-block' },
                wp.element.createElement('div', { className: 'grid-title-wrapper block-grid-label' },
                    wp.element.createElement('label', { htmlFor: 'grid-title-element' }, 'Title'),
                    wp.element.createElement('input', {
                        id: 'grid-search-element',
                        type: 'text',
                        value: props.attributes.title,
                        onChange: updateTitle,
                        placeholder: 'Title'
                    }),
                ),
                wp.element.createElement('p', { className: 'grid-search-text' },
                    'Displays all grid search filter yachts'
                ),               
            )
        );
    },

    save: function () {
        return null; // Server-side rendering only
    }
});

