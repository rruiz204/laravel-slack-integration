<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceToken extends Model
{
    use HasFactory;

    protected $table = 'workspace_tokens';

    protected $fillable = ['team_name', 'access_token', 'channel', 'channel_id'];   
}
