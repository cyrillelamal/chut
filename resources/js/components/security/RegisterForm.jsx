import React from "react";
import {Button, Form} from "react-bootstrap";
import {login, register} from "../../services/security";
import {UserContext} from "./UserContext";

export default class RegisterForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            email: '',
            password: '',
            submitted: false,
            errors: {},
        };
    }

    disclaimer = 'By clicking Sign up, you agree to the terms of use.' //* TODO: i18n */}

    handleSubmit = (e) => {
        e.preventDefault();
        this.setState({submitted: true});

        const {name, email, password} = this.state;

        register({name, email, password})
            .then(() => login({email, password}))
            .then(this.context.setUser)
            .catch(({response}) => {
                const {data} = response;
                const {errors} = data;
                this.setState({submitted: false, errors})
            });
    }

    handleChange = ({target}) => {
        const {name, value} = target;
        this.setState({[name]: value});
    }

    render() {
        return (
            <Form className="p-4 p-md-5 border rounded-3 bg-light" onSubmit={this.handleSubmit}>

                {/* TODO: i18n */}
                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="text"
                        placeholder={'Your name'}
                        name="name"
                        value={this.state.name}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{'Your name'}</Form.Label>
                    {this.state.errors.name && this.state.errors.name.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
                </Form.Group>

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
                    {this.state.errors.email && this.state.errors.email.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
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
                    {this.state.errors.password && this.state.errors.password.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
                </Form.Group>

                <Button variant="primary" className="w-100 btn-lg" type="submit" disabled={this.state.submitted}>
                    {'Sign up'}{/* TODO: i18n */}
                </Button>

                <hr className="my-4"/>
                <small className="text-muted">{this.disclaimer}</small>
            </Form>
        );
    }
}

RegisterForm.contextType = UserContext;
