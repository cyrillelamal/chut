import React from "react";
import {Link} from "react-router-dom";
import Anonymous from "../security/Anonymous";
import Header from "./Header";

export default class Index extends React.Component {
    render() {
        return (
            <Anonymous>
                <div className="container py-4">

                    <Header/>

                    <div className="p-5 mb-4 bg-light rounded-3">
                        <div className="container-fluid py-5">
                            <h1 className="display-5 fw-bold">{'chut'}{/* TODO: i18n */}</h1>
                            <p className="col-md-8 fs-4">
                                {'Instant messaging application'}{/* TODO: i18n */}
                            </p>
                            <div className="d-flex flex-row justify-content-start">
                                <div className="">
                                    <Link to="/login" className="btn btn-outline-secondary">
                                        {'Log in'}{/* TODO: i18n */}
                                    </Link>
                                </div>
                                <div className="ps-2">
                                    <Link to="/register" className="btn btn-outline-primary mr-3">
                                        {'Sign up'}{/* TODO: i18n */}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Anonymous>
        );
    }
}
