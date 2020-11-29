import React from 'react';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { authenticationService } from '../_services/authenticationService';
import { Redirect } from 'react-router-dom'
function login(props) {
    // let email = document.getElementById('email').value;
    // let password = document.getElementById('password').value;
    // let user = { email: email, password: password }
    console.log(props)
    // authenticationService.login(user)
    //     .then(data => {
    //         // this.setState({
    //         //     props.redirect: true
    //         //   })
    //     })

}

class Login extends React.Component {

    constructor(props) {
        super(props)
        this.state = {
            redirect: false
        }
    }

    renderRedirect () {
        if (this.state.redirect) {
            return <Redirect to='/ordinateurs' />
        }
    }

    render() {
        return (
            <Container component="main" maxWidth="xs">
                <CssBaseline />
                <div>
                    <Typography component="h1" variant="h5" className='text-center'>
                        Identifiez-vous
                    </Typography>
                    <form noValidate>
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            id="email"
                            label="Email Address"
                            name="email"
                            autoComplete="email"
                            autoFocus
                        />
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Password"
                            type="password"
                            id="password"
                            autoComplete="current-password"
                        />
                        {this.renderRedirect()}
                        <Button
                            fullWidth
                            variant="contained"
                            color="primary"
                            onClick={login(this.state.redirect)}
                        >
                            Connexion
                        </Button>
                    </form>
                </div>
            </Container>
        )
    }
}

export default Login;