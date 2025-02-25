wp.blocks.registerBlockType('custom/banner-filter-block', {
    title: 'Banner Filter Block',
    icon: 'admin-appearance',
    category: 'yacht-manager',

    attributes: {
        title: { type: 'string', default: '' },
        imageUrl: { type: 'string', default: '' },
        buttonText: { type: 'string', default: '' },
        buttonUrl: { type: 'string', default: '' }
    },

    edit: function (props) {
        const { attributes, setAttributes } = props;

        function updateTitle(event) {
            setAttributes({ title: event.target.value });
        }

        function updateButtonText(event) {
            setAttributes({ buttonText: event.target.value });
        }

        function updateButtonUrl(event) {
            setAttributes({ buttonUrl: event.target.value });
        }
        
        function onSelectImage(media) {
            setAttributes({ imageUrl: media.url });
        }

        return (
            wp.element.createElement('div', { className: 'custom-banner-filter-block' },
                wp.element.createElement('div', { className: 'banner-title-wrapper block-banner-label' },
                    wp.element.createElement('label', { htmlFor: 'banner-title-element' }, 'Title'),
                    wp.element.createElement('input', {
                        id: 'banner-title-element',
                        type: 'text',
                        value: attributes.title,
                        onChange: updateTitle,
                        placeholder: 'Title'
                    })
                ),
                wp.element.createElement(wp.blockEditor.MediaUpload, {
                    onSelect: onSelectImage,
                    allowedTypes: ['image'],
                    render: ({ open }) => (
                        wp.element.createElement('div', { className: 'banner-image-wrap' },
                            attributes.imageUrl &&
                            wp.element.createElement('img', { src: attributes.imageUrl, alt: 'Selected Image', style: { maxWidth: '25%', height: 'auto' } }),
                            wp.element.createElement('button', { type: 'button', onClick: open }, 'Select Image')
                        )
                    )
                }),
                wp.element.createElement('div', { className: 'banner-button-title block-banner-label' },
                    wp.element.createElement('label', { htmlFor: 'banner-button-text' }, 'Button Text'),
                    wp.element.createElement('input', {
                        id: 'banner-button-text',
                        type: 'text',
                        value: attributes.buttonText,
                        onChange: updateButtonText,
                        placeholder: 'Button Text'
                    })
                ),
                wp.element.createElement('div', { className: 'banner-button-url block-banner-label' },
                    wp.element.createElement('label', { htmlFor: 'banner-button-url' }, 'Button URL'),
                    wp.element.createElement('input', {
                        id: 'banner-button-url',
                        type: 'text',
                        value: attributes.buttonUrl,
                        onChange: updateButtonUrl,
                        placeholder: 'Button URL'
                    })
                )
            )
        );
    },

    save: function () {
        return null; // Server-side rendering only
    }
});
