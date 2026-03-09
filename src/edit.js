import { useBlockProps, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const { mediaID, mediaURL, mediaTitle, mediaSize, fileLabel, customName } = attributes;

    const onSelectFile = (media) => {
        const ext = media.url.split('.').pop().toUpperCase();
        let label = ext.substring(0, 4);
        
        // Grouping logic for all accepted types
        if (['DOC', 'DOCX', 'ODT'].includes(ext)) label = 'DOC';
        if (['XLS', 'XLSX', 'ODS'].includes(ext)) label = 'XLS';
        if (['PPT', 'PPTX'].includes(ext)) label = 'SLIDE';
        if (media.mime.includes('audio/')) label = 'MP3';
        if (media.mime.includes('video/')) label = 'MP4';

        setAttributes({
            mediaID: media.id,
            mediaURL: media.url,
            mediaTitle: media.title,
            mediaSize: media.filesizeHumanReadable,
            fileLabel: label
        });
    };

    return (
        <div {...useBlockProps({ className: 'wpdm-download-row' })}>
            {!mediaID ? (
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={onSelectFile}
                        render={({ open }) => (
                            <Button isPrimary onClick={open}>Select File from Media Library</Button>
                        )}
                    />
                </MediaUploadCheck>
            ) : (
                <>
                    <div className="wpdm-file-type-icon">{fileLabel}</div>
                    <div className="wpdm-download-details">
                        <TextControl
                            label="Customize Display Name"
                            value={customName}
                            onChange={(val) => setAttributes({ customName: val })}
                            placeholder={mediaTitle}
                        />
                        <div className="wpdm-download-size">{mediaSize}</div>
                    </div>
                    <Button isDestructive onClick={() => setAttributes({ mediaID: null })}>Remove</Button>
                </>
            )}
        </div>
    );
}
