async function consultarUsuarioBD() {
    try {
        const response = await fetch('busca_usuario.php');
        if (!response.ok) {
            throw new Error('Erro ao pegar dados');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro:', error);
        return [];
    }
}

