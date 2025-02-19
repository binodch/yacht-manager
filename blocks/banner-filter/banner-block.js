wp.blocks.registerBlockType('custom/banner-filter-block', {
    title: 'Banner Filter Block',
    icon: 'admin-comments',
    category: 'widgets',

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
            wp.element.createElement('div', { className: 'custom-banner-filter-block' },
                wp.element.createElement('input', {
                    type: 'text',
                    value: props.attributes.title,
                    onChange: updateTitle,
                    placeholder: 'Title'
                }),
                wp.element.createElement('textarea', {
                    value: props.attributes.description,
                    onChange: updateDescription,
                    placeholder: 'Description'
                })
            )
        );
    },

    save: function () {
        return null; // Server-side rendering only
    }
});