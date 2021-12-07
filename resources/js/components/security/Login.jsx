import React from "react";
import Anonymous from "./Anonymous";
import Header from "../common/Header";
import {Link} from "react-router-dom";
import LoginForm from "./LoginForm";

export default class Login extends React.Component {
    render() {
        return (
            <Anonymous>
                <div className="container py-4">

                    <Header/>

                    <div className="row align-items-center g-lg-5 py-5">

                        <div className="col-md-10 mx-auto col-lg-5">
                            <h1 className="mb-3 text-center">
                                {'Log in'}{/* TODO: i18n */}
                            </h1>
                            <LoginForm/>
                            <p className="mt-2 text-center">
                                <Link to="/register">
                                    {'Or create a new account'}{/* TODO: i18n */}
                                </Link>
                            </p>
                        </div>

                    </div>
                </div>
            </Anonymous>
        );
    }
}
