<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'subject',
        'body',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Obtener un template por su clave
     */
    public static function getByKey(string $key): ?self
    {
        return self::where('key', $key)->where('active', true)->first();
    }

    /**
     * Reemplazar variables en el texto del template
     */
    public function replaceVariables(array $variables): string
    {
        $text = $this->body;
        foreach ($variables as $key => $value) {
            $text = str_replace('{{' . $key . '}}', $value, $text);
        }
        return $text;
    }

    /**
     * Reemplazar variables en el asunto
     */
    public function replaceSubjectVariables(array $variables): string
    {
        $text = $this->subject;
        foreach ($variables as $key => $value) {
            $text = str_replace('{{' . $key . '}}', $value, $text);
        }
        return $text;
    }
}
