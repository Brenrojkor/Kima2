-- =====================================================
-- Object:  Table [dbo].[Categoria]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Categoria] (
    [Categoria_ID] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY,
    [TipoCategoria] [varchar](50) NOT NULL,
    [NombrePersonalizado] [varchar](50) NULL,

    CHECK (
        TipoCategoria IN ('Otros', 'Cosméticos', 'Productos Médicos', 'Químicos')
    )
);