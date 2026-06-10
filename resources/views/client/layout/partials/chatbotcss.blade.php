<style>
    #chatToggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 52px;
        height: 52px;
        z-index: 9999;
        border-radius: 50%;
        border: none;
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 16px 32px rgba(13, 110, 253, 0.24);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #chatWidget {
        display: none;
        position: fixed;
        bottom: 88px;
        right: 20px;
        width: 360px;
        z-index: 9999;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #fff;
    }

    #chatWidget .chat-header {
        background: linear-gradient(135deg, #0d6efd 0%, #3b8dff 100%);
        color: #fff;
        padding: 14px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    #chatWidget .chat-header .chat-actions button {
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #chatbox {
        max-height: 330px;
        overflow-y: auto;
        background: #f4f7fb;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-row {
        display: flex;
        width: 100%;
    }

    .chat-user {
        justify-content: flex-end;
    }

    .chat-label {
        font-size: 11px;
        color: rgba(0,0,0,0.55);
        margin-bottom: 4px;
        letter-spacing: 0.02em;
    }

    .chat-user .chat-label {
        text-align: right;
    }

    .chat-message {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 18px;
        max-width: 78%;
        line-height: 1.5;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .chat-user .chat-message {
        background: #0d6efd;
        color: #fff;
        border-bottom-right-radius: 6px;
    }

    .chat-bot .chat-message {
        background: #fff;
        color: #252f3f;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-bottom-left-radius: 6px;
    }

    .chat-input-area {
        padding: 12px 14px;
        background: #ffffff;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 10px;
        align-items: center;
    }

    #chatInput {
        flex: 1;
        min-width: 0;
        border-radius: 999px;
        border: 1px solid rgba(13, 110, 253, 0.26);
        height: 40px;
    }

    #chatInput:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    #chatWidget .btn-send {
        min-width: 72px;
        border-radius: 999px;
        height: 40px;
    }
</style>
