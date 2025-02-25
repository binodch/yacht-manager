wp.blocks.registerBlockType('custom/featured-entity-block', {
    title: 'Featured Entity Block',
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

        function updateDescription(event) {
            props.setAttributes({ description: event.target.value });
        }

        return (
            wp.element.createElement('div', { className: 'custom-featured-entity-block' },
                wp.element.createElement('div', { className: 'featured-title-wrapper block-featured-label' },
                    wp.element.createElement('label', { htmlFor: 'featured-title-element' }, 'Title'),
                    wp.element.createElement('input', {
                        id: 'featured-title-element',
                        type: 'text',
                        value: props.attributes.title,
                        onChange: updateTitle,
                        placeholder: 'Title'
                    }),
                ),
                wp.element.createElement('div', { className: 'featured-textarea-wrapper' },
                    wp.element.createElement('label', { htmlFor: 'featured-textarea-element' }, 'Description'), 
                    wp.element.createElement('textarea', {
                        id: 'featured-textarea-element',
                        value: props.attributes.description,
                        onChange: updateDescription,
                        placeholder: 'Description',
                        rows: 5
                    })
                )
                
            )
        );
    },

    save: function () {
        return null; // Server-side rendering only
    }
});