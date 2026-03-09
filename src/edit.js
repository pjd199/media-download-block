import { useBlockProps, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const { files, headerText } = attributes;

    const onSelectFiles = (mediaItems) => {
        const newFiles = mediaItems.map(media => ({
            id: media.id,
            url: media.url,
            realFileName: media.filename, // The actual filename on the server
            displayName: media.title,    // The name you want users to see
            fileSize: media.filesizeHumanReadable,
            fileLabel: media.url.split('.').pop().toUpperCase().substring(0, 4)
        }));
        setAttributes({ files: [...files, ...newFiles] });
    };

    const updateFileTitle = (newName, index) => {
        const updatedFiles = [...files];
        updatedFiles[index].displayName = newName;
        setAttributes({ files: updatedFiles });
    };

    const removeFile = (index) => {
        setAttributes({ files: files.filter((_, i) => i !== index) });
    };

    return (
        <div {...useBlockProps({ className: 'mdb-editor-container' })}>
            <TextControl
                label={__('Block Header', 'mdb')}
                value={headerText}
                onChange={(val) => setAttributes({ headerText: val })}
            />

            <div className="mdb-files-list">
                {files.map((file, index) => (
                    <div key={index} className="mdb-download-row mdb-editor-row">
                        <div className="mdb-file-type-icon">{file.fileLabel}</div>
                        <div className="mdb-download-details">
                            <TextControl
                                value={file.displayName}
                                onChange={(val) => updateFileTitle(val, index)}
                                help={`Source: ${file.realFileName} (${file.fileSize})`}
                            />
                        </div>
                        <Button isDestructive onClick={() => removeFile(index)}>×</Button>
                    </div>
                ))}
            </div>

            <MediaUploadCheck>
                <MediaUpload
                    onSelect={onSelectFiles}
                    multiple={true}
                    render={({ open }) => (
                        <Button variant="secondary" onClick={open}>
                            {__('Add Files', 'mdb')}
                        </Button>
                    )}
                />
            </MediaUploadCheck>
        </div>
    );
}