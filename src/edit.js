import { useBlockProps, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const { mediaID, mediaURL, mediaTitle, mediaSize, fileLabel, customName } = attributes;

    const onSelectFile = (media) => {
        const ext = media.url.split('.').pop().toUpperCase();
        let label = ext.substring(0, 4);
        
        // Dynamic icon labeling
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
        <div {...useBlockProps({ className: 'mdb-download-row' })}>
            {!mediaID ? (
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={onSelectFile}
                        render={({ open }) => (
                            <Button variant="primary" onClick={open}>
                                {__('Select File', 'mdb')}
                            </Button>
                        )}
                    />
                </MediaUploadCheck>
            ) : (
                <>
                    <div className="mdb-file-type-icon">{fileLabel}</div>
                    <div className="mdb-download-details">
                        <TextControl
                            label={__('Custom Display Name', 'mdb')}
                            value={customName}
                            onChange={(val) => setAttributes({ customName: val })}
                            placeholder={mediaTitle}
                        />
                        <div className="mdb-download-size">{mediaSize}</div>
                    </div>
                    <Button 
                        variant="tertiary" 
                        isDestructive 
                        onClick={() => setAttributes({ mediaID: null, mediaURL: null })}
                    >
                        {__('Remove', 'mdb')}
                    </Button>
                </>
            )}
        </div>
    );
}