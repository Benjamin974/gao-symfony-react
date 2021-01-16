import React from 'react';
import IconButton from '@material-ui/core/IconButton';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import Icon from '@material-ui/core/Icon';
import Axios from 'axios';
import Autocomplete from '@material-ui/lab/Autocomplete';
import { Container, Row, Col } from 'reactstrap';

function OpenDialog(props) {

    const [open, setOpen] = React.useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const openAuto = () => {
        return React.useState(false)
    }


    const addAttribution = () => {
        let name = document.getElementById('search').value;
        Axios.post('attributions/add', { id_client: name, id_ordinateur: props.ordinateur.id, horaire: props.horaire, date: props.date }).then(({ data }) => {
            console.log(data);
            props.onSelectAttribution(data)
        })
        setOpen(false);
    }

    return (
        <Row>
            <IconButton variant="outlined" color="primary" onClick={handleClickOpen}>
                <Icon>add_circle</Icon>
            </IconButton>
            <Dialog
                open={open}
                onClose={handleClose}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
            >
                <DialogTitle id="alert-dialog-title">{"Ajouter une attribution"}</DialogTitle>
                <DialogContent>
                    <Autocomplete
                        id="search"
                        open={open}
                        options={props.clients}
                        getOptionLabel={(option) => option.name}
                        style={{ width: 300 }}
                        renderInput={(params) => <TextField {...params} label="Nom" variant="outlined" />}
                    />
                </DialogContent>
                <DialogActions>
                    <IconButton onClick={handleClose} color="primary" >
                        Annuler
                    </IconButton>
                    <IconButton onClick={addAttribution} color="primary" autoFocus>
                        Valider
                    </IconButton>
                </DialogActions>
            </Dialog>
        </Row>
    );
}

class AddAttribution extends React.Component {
    constructor(props) {
        super(props)
        this.state = { clients: [] }

    }
    componentDidMount() {
        this.initialize();

    }

    initialize() {
        Axios.get(`clients/search`).then(({ data }) => {
            data.forEach(client => {
                this.state.clients.push(client);
            })

        })
    }

    render() {

        return (
            <div>
                <OpenDialog onSelectAttribution={this.props.onSelectAttribution} date={this.props.date} ordinateur={this.props.ordinateur} horaire={this.props.horaire} clients={this.state.clients} />
            </div>
        );
    }

}




export default AddAttribution;