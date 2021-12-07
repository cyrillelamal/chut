import React from "react";
import Anonymous from "./Anonymous";
import RegisterForm from "./RegisterForm";
import {Link} from "react-router-dom";
import Header from "../common/Header";

export default class Register extends React.Component {
    render() {
        return (
            <Anonymous>
                <div className="container py-4">
                    <Header/>

                    <div className="row align-items-center g-lg-5 py-5">

                        <div className="col-lg-7 text-center text-lg-start my-4">
                            <h1 className="display-4 fw-bold lh-1 mb-3">
                                {'Sign up'}{/* TODO: i18n */}
                            </h1>
                            <p className="fs-4">
                                {'Start to use this awesome application'}{/* TODO: i18n */}
                            </p>
                            <div className="d-grid gap-2 d-md-flex justify-content-center justify-content-lg-start">
                                <Link to="/login">
                                    {'Already have an account?'}{/* TODO: i18n */}
                                </Link>
                            </div>
                        </div>

                        <div className="col-md-10 mx-auto col-lg-5">
                            <RegisterForm/>
                        </div>

                    </div>
                </div>
            </Anonymous>
        );
    }
}
