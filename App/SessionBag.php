<?php

namespace App;

final class SessionBag
{
    private const SESSION_ERROR_NAME = 'errors';
    private const SESSION_FLASH_NAME = 'flash_messages';
    private const SESSION_FORM_DATA_NAME = 'form_data';

    /** Adiciona uma mensagem de erro na mochila da sessão */
    public static function putError(string $errorMessage): void
    {
        $_SESSION[self::SESSION_ERROR_NAME][] = $errorMessage;

        session_write_close();
    }

    /** Adiciona uma mensagem de sucesso na mochila da sessão */
    public static function putFlashMessage(string $flashMessage): void
    {
        $_SESSION[self::SESSION_FLASH_NAME][] = $flashMessage;

        session_write_close();
    }

    /**
     * Adiciona um valor de formulário na mochila da sessão.
     * Muito útil para retornar valores da sessão de um formulário inválido.
     */
    public static function putFormDataValue(array $data): void
    {
        $_SESSION[self::SESSION_FORM_DATA_NAME] = $data;

        session_write_close();
    }

    public static function clearBag(): void
    {
        session_unset();
    }
}