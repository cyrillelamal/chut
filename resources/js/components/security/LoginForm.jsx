import React from "react";
import {Alert, Button, Form} from "react-bootstrap";
import {login} from "../../services/security";
import {UserContext} from "./UserContext";

export default class LoginForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: '',
            submitted: false,
            message: null,
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();
        this.setState({submitted: true, message: null});

        const {email, password} = this.state;

        login({email, password})
            .then(this.context.setUser)
            .catch(({response}) => {
                const {data} = response;
                const {message} = data;
                this.setState({submitted: false, message})
            });
    }

    handleChange = ({target}) => {
        const {name, value} = target;
        this.setState({[name]: value});
    }

    render() {
        return (
            <Form className="p-4 p-md-5 border rounded-3 bg-light" onSubmit={this.handleSubmit}>
                {this.state.message && (<Alert variant="danger">{this.state.message}</Alert>)}

                {/* TODO: i18n */}
                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="email"
                        placeholder={'your@mail.com'}
                        name="email"
                        value={this.state.email}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{'Email address'}</Form.Label>
                </Form.Group>

                {/* TODO: i18n */}
                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="password"
                        placeholder={'Password'}
                        name="password"
                        value={this.state.password}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{'Password'}</Form.Label>
                </Form.Group>

                <Button variant="success" className="w-100 btn-lg" type="submit" disabled={this.state.submitted}>
                    {'Log in'}{/* TODO: i18n */}
                </Button>
            </Form>
        );
    }
}

LoginForm.contextType = UserContext;
