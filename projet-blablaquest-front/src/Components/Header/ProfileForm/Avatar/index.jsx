import { Avatar as MuiAvatar, Button as MuiButton, makeStyles } from "@material-ui/core";
import { grey } from "@material-ui/core/colors";
import { CloudUpload as MuiCloudUpload, Delete as MuiDelete } from "@material-ui/icons";
import { spacing } from "@material-ui/system";
import React, { createRef, useState } from "react";
import styled from "styled-components";
import './styles.scss';

const Button = styled(MuiButton)(spacing);
const UploadIcon = styled(MuiCloudUpload)(spacing);
const DeleteIcon = styled(MuiDelete)(spacing);

const CenteredContent = styled.div`
    text-align: center;`;

const useStyles = makeStyles((theme) => ({
    root: {
        display: "flex",
        "& > *": {
            margin: theme.spacing(1)
        }
    },
    large: {
        width: theme.spacing(24),
        height: theme.spacing(24)
    }
}));

const BigAvatar = styled(MuiAvatar)`
    width: 130px;
    height: 130px;
    margin: 0 auto 16px;
    border: 1px solid ${grey[500]};
    box-shadow: 0 0 1px 0 ${grey[500]} inset, 0 0 1px 0 ${grey[500]};
  `;

const AvatarUpload = () => {
    const classes = useStyles();

    const [image, _setImage] = useState(null);
    const inputFileRef = createRef(null);

    const cleanup = () => {
        URL.revokeObjectURL(image);
        inputFileRef.current.value = null;
    };

    const setImage = (newImage) => {
        if (image) {
            cleanup();
        }
        _setImage(newImage);
    };

    const handleOnChange = (event) => {
        const newImage = event.target?.files?.[0];

        if (newImage) {
            setImage(URL.createObjectURL(newImage));
        }
    };

    const handleClick = (event) => {
        if (image) {
            event.preventDefault();
            setImage(null);
        }
    };

    return (
        <CenteredContent className="container-profile-picture">
            <BigAvatar
                className={classes.large}
                $withBorder
                alt="Avatar"
                src={image || "../../../src/assets/img/default.jpg"}
            />
            <input
                ref={inputFileRef}
                accept="image/*"
                hidden
                id="avatar-image-upload"
                type="file"
                onChange={handleOnChange}
            />
            <label htmlFor="avatar-image-upload">
                <Button
                    className="upload-button"
                    variant="contained"
                    color="primary"
                    component="span"
                    mb={2}
                    onClick={handleClick}
                >
                    {image ? <DeleteIcon mr={2} /> : <UploadIcon mr={2} />}
                    {image ? "Supprimer" : "Charger"}
                </Button>
            </label>
        </CenteredContent>
    );
};

export default AvatarUpload;
