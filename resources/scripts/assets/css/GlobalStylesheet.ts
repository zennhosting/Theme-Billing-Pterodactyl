import tw from 'twin.macro';
import { createGlobalStyle } from 'styled-components/macro';

export default createGlobalStyle`
    body {
        ${tw`font-sans bg-neutral-800 text-neutral-200`};
        letter-spacing: 0.015em;
    }

    h1, h2, h3, h4, h5, h6 {
        ${tw`font-medium tracking-normal font-header`};
    }

    p {
        ${tw`text-neutral-200 leading-snug font-sans`};
    }

    form {
        ${tw`m-0`};
    }

    textarea, select, input, button, button:focus, button:focus-visible {
        ${tw`outline-none`};
    }

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield !important;
    }

    /* Scroll Bar Style */
    ::-webkit-scrollbar {
        background: none;
        width: 16px;
        height: 16px;
    }

    ::-webkit-scrollbar-thumb {
        border: solid 0 rgb(0 0 0 / 0%);
        border-right-width: 4px;
        border-left-width: 4px;
        -webkit-border-radius: 9px 4px;
        -webkit-box-shadow: inset 0 0 0 1px hsl(211, 10%, 53%), inset 0 0 0 4px hsl(209deg 18% 30%);
    }

    ::-webkit-scrollbar-track-piece {
        margin: 4px 0;
    }

    ::-webkit-scrollbar-thumb:horizontal {
        border-right-width: 0;
        border-left-width: 0;
        border-top-width: 4px;
        border-bottom-width: 4px;
        -webkit-border-radius: 4px 9px;
    }

    ::-webkit-scrollbar-corner {
        background: transparent;
    }

    .Socials {
    margin-top: 15px;
    display: flex;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    }

    a.button {
        width: 48%;
        color: white !important;
        margin-bottom: 10px;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        background: transparent;
        height: 38px;
        padding: 0 1.25rem;
        border: none !important;
        border-radius: 0.5rem;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        color: var(--text-primary);
        font-size: 0.9rem;
        font-weight: var(--font-weight-heavy);
        line-height: 1;
        text-transform: uppercase;
        white-space: nowrap;
        -webkit-transition: opacity 0.25s ease;
        transition: opacity 0.25s ease;
        margin-right: 0.25rem;
        margin-left: 0.25rem;
    }

    a.button.discord {
    background: #5865f2;
    }

    a.button.github {
    background: #22272b;
    }

    a.button.google {
    background: #f2b300;
    }

    a.button.whmcs {
    background: #008640;
    }
    .kOFLMG {
        margin-left: 24px !important;
    }
    img.LoginFormContainer___StyledImg-sc-cyh04c-5.iKtZRB {
        display: none !important;
    }
`;
