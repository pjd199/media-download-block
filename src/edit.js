import { useBlockProps, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { Button, TextControl, PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const { files, headerText, layoutStyle } = attributes;

    const onSelectFiles = (mediaItems) => {
        const newFiles = mediaItems.map(media => ({
            id: media.id,
            url: media.url,
            realFileName: media.filename,
            displayName: media.title,
            fileSize: media.filesizeHumanReadable,
            fileLabel: media.url.split('.').pop().toUpperCase().substring(0, 4)
        }));
        setAttributes({ files: [...files, ...newFiles] });
    };

    const moveFile = (oldIndex, newIndex) => {
        if (newIndex < 0 || newIndex >= files.length) return;
        const updatedFiles = [...files];
        const [movedItem] = updatedFiles.splice(oldIndex, 1);
        updatedFiles.splice(newIndex, 0, movedItem);
        setAttributes({ files: updatedFiles });
    };

    const updateFileTitle = (newName, index) => {
        const updatedFiles = [...files];
        updatedFiles[index].displayName = newName;
        setAttributes({ files: updatedFiles });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Layout Settings', 'mdb')}>
                    <SelectControl
                        label={__('Display Style', 'mdb')}
                        value={layoutStyle}
                        options={[
                            { label: __('Standard Row', 'mdb'), value: 'row' },
                            { label: __('Compact List', 'mdb'), value: 'compact' },
                        ]}
                        onChange={(val) => setAttributes({ layoutStyle: val })}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...useBlockProps({ className: `mdb-editor-wrapper mdb-style-${layoutStyle}` })}>
                <TextControl
                    label={__('Block Header', 'mdb')}
                    value={headerText}
                    onChange={(val) => setAttributes({ headerText: val })}
                />

                <div className="mdb-files-list">
                    {files.map((file, index) => (
                        <div key={index} className="mdb-download-row mdb-editor-row">
                            <div className="mdb-editor-controls">
                                <Button icon="arrow-up-alt2" onClick={() => moveFile(index, index - 1)} disabled={index === 0} />
                                <Button icon="arrow-down-alt2" onClick={() => moveFile(index, index + 1)} disabled={index === files.length - 1} />
                            </div>
                            <div className="mdb-file-type-icon">{file.fileLabel}</div>
                            <div className="mdb-download-details">
                                <TextControl
                                    value={file.displayName}
                                    onChange={(val) => updateFileTitle(val, index)}
                                    help={`${__('Source:', 'mdb')} ${file.realFileName} (${file.fileSize})`}
                                />
                            </div>
                            <Button isDestructive icon="trash" onClick={() => setAttributes({ files: files.filter((_, i) => i !== index) })} />
                        </div>
                    ))}
                </div>

                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={onSelectFiles}
                        multiple={true}
                        render={({ open }) => (
                            <Button variant="secondary" onClick={open} className="mdb-add-btn">{__('Add Files', 'mdb')}</Button>
                        )}
                    />
                </MediaUploadCheck>
            </div>
        </>
    );
}